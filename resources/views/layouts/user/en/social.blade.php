<section class="flex vertical start bg-white main-section ref">
    <h2>Social Info</h2>
    <div class="flex around mw ref-info">
        <div class="flex vertical center ref-link">
            <p>Your ref link is:</p>
            <a href="{{ url("/register/{$ref_info['link']}") }}">{{ url("/register/{$ref_info['link']}") }}</a>
        </div>
        <div class="w4 ref-count flex vertical center divisor-bg">
            <p>Number of refs:</p>
            <p>{{ $ref_info['count'] }}</p>
        </div>
    </div>
    <div class="ref-table mw">
        <table class="mw">
            <tbody class="mw">
                @foreach($ref_info['table'] as $date => $count)
                    <tr>
                        <td align="center">
                            <p>
                                {{ $date }}
                            </p>
                        </td>
                        <td align="center">
                            <p>
                                {{ $count.' '.str_plural('ref', $count) }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="social-links flex center mw">
        <div class="facebook flex center">
            <a onclick="window.open(
            'http://www.facebook.com/share.php?u=https://www.getmestuff.net&title=GetMeStuff',
            'Facebook | Share',
            'toolbar=0, status=0, width=700, height=400'
            )"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </div>
        <div class="vk flex center" id="vk_share_button"></div>
        <div class="twitter flex center">
            <a onclick="window.open(
                'http://twitter.com/home?status=GetMeStuff+https://www.getmestuff.net/',
                'Twitter | Share',
                'toolbar=0, status=0, width=700, height=400'
            )">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>
