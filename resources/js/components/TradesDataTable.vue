<template>
    <v-container>
        <div class = 'col-12'>
            <div class = 'float-right'>
                <button class = 'btn btn-primary' v-on:click="clearTradeForm()">Add Entry</button>    
            </div>
            <h2>Trades</h2>
        </div>
        <trade-entry-form v-if="showForm" v-bind:showForm="showForm" v-bind:trade="tradeFormData" v-on:on-form-update="handleFormUpdate"></trade-entry-form>
        <v-data-table
            :headers="headers"
            :items="trades"
            :items-per-page="5"
            class="elevation-1"
        >
            
            <template v-if = "!loading" v-slot:item = "{item}">
                <tr>
                    <td> {{ new Date(item.entered_at).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }) }} </td>
                    <td> {{ (item.closed_at != null) ? new Date(item.closed_at).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }) : '' }} </td>
                    <td> {{ item.asset_pair }} </td>
                    <td class="text-center"> <span v-bind:class = "getTradePositionClass(item)"> {{ item.position }} </span> </td>
                    <td class="text-right"> {{ item.opening_price }} </td>
                    <td class="text-right"> {{ item.quantity }} </td>
                    <td class="text-right"> {{ calculateAmount(item).toLocaleString() }} </td>
                    <td class="text-right"> {{ item.stop_loss }} </td>
                    <td class="text-right"> {{ item.closing_price }} </td>
                    <td v-bind:class="getTradeResultClass(item)"> {{ calculateProfitLossPercent(item).toLocaleString() }}% </td>
                    <td v-bind:class="getTradeResultClass(item)"> {{ calculateProfitLossAmount(item).toLocaleString() }} </td>
                    <td> <a href='#' v-on:click.prevent="loadTradeData(item)"><i class="far fa-edit"></i></a> </td>
                </tr>
            </template>
            
        </v-data-table>
    </v-container>
</template>

<script>
export default {
    data: () => (
        {
            loading: true,
            showForm: false,
            trades: [
                {}
            ],
            tradeFormData: {},
            headers: [
                { text: "Opening Date", value: "entered_at" },
                { text: "Closing Date", value: "closed_at" },
                { text: "Asset", value: "asset_pair" },
                { text: "Type", value: "type" },
                { text: "Opening Price", value: "opening_price" },
                { text: "Quantity", value: "quantity" },
                { text: "Amount" },
                { text: "Stop Loss", value: "stop_loss" },
                { text: "Closing Price", value: "closing_price" },
                { text: "PnL" },
                { text: "PnL Amount" },
                { text: "Actions" },
            ],
        }
    ),
    mounted() {
        this.tradeList();
    },
    computed: {

    },
    methods: {
        tradeList: function() {
            axios.get('/api/1/trades')
            .then(response => {
                this.trades = response.data.entries;
                this.loading = false;
            })
        },
        calculateAmount: function(item) {
            return item.quantity * item.opening_price;
        },
        calculateProfitLossPercent: function(item) {
            if (item.position) {
                if ('Short' == item.position) {
                    return ((item.opening_price - item.closing_price) / item.opening_price) * 100;
                } else {
                    return ((item.closing_price - item.opening_price) / item.opening_price) * 100;
                }
                
                return 0;
            }
        },
        calculateProfitLossAmount: function(item) {
            if (item.position) {
                
                let pnlPercent = 0;
                let openAmount = 0;
                
                pnlPercent = this.calculateProfitLossPercent(item);
                openAmount = this.calculateAmount(item);
                
                if ('Short' == item.position) {
                    return (openAmount + (openAmount * (pnlPercent / 100))) - openAmount;
                } else {
                    return (openAmount + (openAmount * (pnlPercent / 100))) - openAmount;
                }
                
                return 0;
            }
        },
        getTradePositionClass: function(item) {
            if (item.position) {
                if ('Short' == item.position) {
                    return 'badge badge-danger';
                } else {
                    return 'badge badge-success';
                }
                
                return '';
            }
        },
        getTradeResultClass: function(item) {
            if (item.closed_at) {
                let pnl = this.calculateProfitLossPercent(item);
                
                if (0 > pnl) {
                    return 'bg-danger text-right';
                }
                
                return 'bg-success text-right';
            }
            
            return 'bg-info text-right';
        },
        clearTradeForm: function() {
            this.tradeFormData = {};
            this.tradeFormData.id = 0;
            this.showForm = true;
        },
        loadTradeData: function(item) {
            this.tradeFormData = item;
            
            this.tradeFormData.id = item.id;
            this.tradeFormData.position = item.position;
            this.tradeFormData.assetPair = item.asset_pair;
            this.tradeFormData.openingPrice = item.opening_price;
            this.tradeFormData.quantity = item.quantity;
            this.tradeFormData.closingPrice = item.closing_price;
            this.tradeFormData.stopLoss = item.stop_loss;
            
            this.tradeFormData.openingDate = null;
            if (item.entered_at != null) {
                this.tradeFormData.openingDate = item.entered_at.substr(0, 10);
            }
            
            this.tradeFormData.closingDate = null;
            if (item.closed_at != null) {
                this.tradeFormData.closingDate = item.closed_at.substr(0, 10);
            }
            
            this.showForm = true;
        },
        handleFormUpdate: function(status) {
            if (status == 'updated') {
                this.tradeList();
            }
            
            this.showForm = false;
        }
    }
};
</script>