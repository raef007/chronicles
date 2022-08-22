<template>
    <v-container>
        <div class="row">
            <div class="col-lg-12">
                <div class="stats-2-block block d-flex">
                    <div class="stats-2 d-flex">
                        <div class="stats-2-arrow low"><i class="fa fa-caret-down"></i></div>
                        <div class="stats-2-content">
                            <strong class="d-block">{{ pnl.summary.total_capital.toLocaleString() }}</strong>
                            <span class="d-block">Capital</span>
                        </div>
                    </div>
                        
                    <div class="stats-2 d-flex">
                        <div class="stats-2-arrow height"><i class="fa fa-caret-up"></i></div>
                        <div class="stats-2-content">
                            <strong class="d-block">{{ pnl.summary.total_pnl.toLocaleString() }}</strong>
                            <span class="d-block">Total PnL</span>
                        </div>
                    </div>
                        
                    <div class="stats-2 d-flex">
                        <div class="stats-2-arrow height"><i class="fa fa-caret-up"></i></div>
                        <div class="stats-2-content">
                            <strong class="d-block">{{ calculateAssetValue.toLocaleString() }}</strong>
                            <span class="d-block">Asset Value</span>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
export default {
    mounted() {
        this.capitalSummary();
    },
    computed: {
        calculateAssetValue: function() {
            return this.pnl.summary.total_capital + this.pnl.summary.total_pnl;
        }
    },
    methods: {
        capitalSummary: function() {
            axios.get('/api/1/pnl-summary')
            .then(response => {
                this.pnl = response.data;
                this.loading = false;
            })
        },
    },
    data: () => ({
        loading: true,
        pnl: {
            summary: {
                total_capital: 0,
                total_pnl: 0
            }
        },
    }),
};
</script>