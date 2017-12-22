<table border="0" cellpadding="0" cellspacing="0" style="margin:0px; background: #f8f8f8; width: 100%;">
    <tbody>
    <tr>
        <td>
            <div style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
                    <div style="padding: 40px; background: #fff;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <b>Hello,</b>
                                    <p>Your wish for <b>{{ $wish->translate('en')->item }}</b> has been completed.</p>
                                    <p>It will be delivered to the following address:</p>
                                    <address style="padding-left: 1em"> 
                                        {{ $wish->address['address_one'] }}<br>
                                        @if($wish->address['address_two'] != '')
                                            {{ $wish->address['address_two'] }}<br>
                                        @endif
                                        {{ $wish->address['city'] }}<br>
                                        {{ $wish->address['post_code'] }}<br>
                                        {{ $wish->address['country'] }}<br>
                                    </address>
                                    <p>If this is wrong, please contact us.</p>
                                    <p><b>- Thanks, GetMeStuff Team</b></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>