<?php


namespace App\Http\Controllers\Admin\Traits;


use Carbon\Carbon;

trait RefactorData
{
    public function refactorData($data)
    {
        return $data->map(function ($item) {
            $data = collect($item)->map(function ($item, $key) {
                if (method_exists($this, $key.'_refactor')) {
                    $methodName = $key.'_refactor';
                    return $this->$methodName($item);
                }
                return $item;
            });

            if (isset($data['first_name']) && isset($data['last_name'])) $data = $this->userFullName($data);
            if (isset($data['type'])) $data = $this->typeSlug($data);
            if (isset($data['priority'])) $data = $this->prioritySlug($data);
            if (isset($data['renew'])) $data = $this->achievementSlug($data);
            if (isset($data['current_amount'])) $data = $this->getFullAmount($data);

            return $data;
        });
    }

    protected function created_at_refactor($item)
    {
        return Carbon::parse($item)->format('d-m-Y');
    }

    protected function updated_at_refactor($item)
    {
        return Carbon::parse($item)->format('d-m-Y');
    }

    protected function user_refactor($item)
    {
        return $item['email'];
    }

    protected function ip_address_refactor($item)
    {
        return long2ip($item);
    }

    protected function address_refactor($item)
    {
        if (is_null($item['address_two'])) {
            $address = $item['address_one'];
        } else {
            $address = $item['address_one'] . ' ' . $item['address_two'];
        }

        $item = array_add($item, 'address_line', $address);

        return $item;
    }

    protected function translations_refactor($item)
    {
        return collect($item)->keyBy('locale')->map(function ($item) {
            return collect($item)->only($this->translatedFields);
        });
    }

    protected function achievementSlug($data)
    {
        if ($data['renew'] == 0) {
            $data['renew_slug'] = 'None';
        } elseif ($data['renew'] == 1) {
            $data['renew_slug'] = 'Monthly';
        } else {
            $data['renew_slug'] = 'Instant';
        }

        return $data;
    }

    protected function typeSlug($data)
    {
        if ($data['type'] == 0) {
            $data['type_slug'] = 'Open';
        } elseif ($data['type'] == 1) {
            $data['type_slug'] = 'In Progress';
        } else {
            $data['type_slug'] = 'Closed';
        }

        return $data;
    }

    protected function prioritySlug($data)
    {
        if ($data['priority'] == 0) {
            $data['priority_slug'] = 'Green';
        } elseif ($data['priority'] == 1) {
            $data['priority_slug'] = 'Yellow';
        } else {
            $data['priority_slug'] = 'Red';
        }

        return $data;
    }

    protected function getFullAmount($data)
    {
        $data['total_current_amount'] = $data['initial_amount'] + $data['current_amount'];

        return $data;
    }

    protected function userFullName($data)
    {
        $name = $data['first_name'].' '.$data['last_name'];
        $data = array_add($data, 'name', $name);

        return $data;
    }
}