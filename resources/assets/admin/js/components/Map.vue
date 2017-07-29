<template>
    <div id="visits-map" style="height: 490px;"></div>
</template>
<script>
    export default {
        props: ['map', 'info'],
        data() {
            return {
                countries: this.map
            }
        },
        mounted() {
            this.makeMap();
        },
        methods: {
            fetch() {
                axios.get('/admin/api/countries/visits').then(({data}) => {
                    this.countries = data;
                    this.makeMap();
                });
            },
            makeMap() {
//                console.log(this.countries);
                $('#visits-map').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: '#FFFFFF',
                    regionStyle: {
                        initial: {
                            fill: '#f4ebc9',
                            'fill-opacity': 1,
                            stroke: 'none'
                        },
                        hover: {
                            "fill-opacity": 0.8,
                            cursor: 'pointer'
                        },
                    },
                    series: {
                        regions: [{
                            values: this.countries,
                            scale: ['#ffa1a1', '#e04747'],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                    onRegionTipShow: (e, el, code) => {
                        if (this.countries.hasOwnProperty(code)) {
                            let user = this.info.users[code];
                            if (user > 1) {
                                el.html(el.html()+' - '+this.countries[code]+' visits ('+user+' users)');
                            } else if (user == 1) {
                                el.html(el.html()+' - '+this.countries[code]+' visits ('+user+' user)');
                            } else {
                                el.html(el.html()+' - '+this.countries[code]+' visits');
                            }
                        } else {
                            el.html(el.html()+' - 0 visits');
                        }
                    }
                });
            }
        }
    }
</script>