<achievements :user="{{ auth()->user() }}" inline-template>
    <section class="flex vertical pos-r start bg-white main-section achievements">
        <h2>Achievements</h2>
        <div class="flex nc-between mw">
            <div class='donated'>
                <div title="{{ auth()->user()->amount_donated }}$">
                    <p>Donated:</p>
                    <p><span id="amount-donated" v-text="donatedShrt"></span>$</p>
                </div>
                <div :title="donated">
                    <p>Recieved:</p>
                    <p><span>{{ shortenNum(auth()->user()->amount_received) }}</span>$</p>
                </div>
            </div>
            <div class="w8 achievements-info">
                @if ($settings[0]->data['on'])
                    <div class="pos-r stars flex nc-between">
                        <div class="w8">
                            <p class="redeem-toggle" @click="changeClass" v-text="$t(currentText)"></p>
                        </div>
                        <p><span id="points-number" v-text="points"></span> <i class="currency fa fa-trophy" aria-hidden="true"></i></p>
                    </div>
                    <div class="expandable mw" v-show="expanded">
                        <redeem :user="{{ auth()->user()->allowed_wishes }}" :prizes="{{ $prizes }}"></redeem>
                    </div>
                    <div class="mw badges" v-show="!expanded">
                        @foreach($achievements as $achievement)
                            <badge image="{{ asset("images/achievements/{$achievement->image}.png") }}"
                                   :achievement="{{ $achievement }}"
                                   :userinfo="{{ auth()->user()->achievements }}"></badge>
                        @endforeach
                    </div>
                @else
                    <div class="empty mw">
                        <p class="mw t-align">Sorry, achievements are currently disabled.</p>
                        <p class="mw t-align">Reason: {{ $reasons[$lang][$settings[0]->data['value']] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</achievements>