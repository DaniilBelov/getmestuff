<tabs>
    <tab name="<i class='fa fa-lg fa-cog' aria-hidden='true'></i>" title="Settings" :selected="true">
        <settings :user="{{ auth()->user() }}"></settings>
    </tab>
    <tab name="<i class='fa fa-lg fa-money' aria-hidden='true'></i>" title="Wallet">
        <wallet :disabled="{{ json_encode($settings[2]->data) }}"
                :commissions="{{ json_encode($settings[1]->data) }}"
                user="{{ auth()->user()->email }}"></wallet>
    </tab>
    <tab name="<i class='fa fa-lg fa-trophy' aria-hidden='true'></i>" title="Achievements">
        @include ('layouts.user.'.$lang.'.achievements')
    </tab>
    <tab name="<i class='fa fa-lg fa-pencil' aria-hidden='true'></i>" title="Make a Wish">
        <make last_currency="{{ cache('currency.'.auth()->user()->id) }}" :user="{{ auth()->user() }}"></make>
    </tab>
    <tab name="<i class='fa fa-lg fa-globe' aria-hidden='true'></i>" title="Social">
        @include ('layouts.user.'.$lang.'.social')
    </tab>
</tabs>