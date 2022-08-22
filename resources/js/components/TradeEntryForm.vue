<template>
    <v-dialog
        v-model="show"
        persistent
        max-width="600px"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Trade Entry</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <div v-if = "errorMessage != ''"class="alert alert-danger" role="alert" v-html = "errorMessage">
                        
                    </div>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                label="Asset Pair *"
                                v-model = 'trade.assetPair'
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                                :items="['Long', 'Short']"
                                label="Position *"
                                v-model = 'trade.position'
                                required
                            ></v-select>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                                label="Opening Date *"
                                type="date"
                                v-model = 'trade.openingDate'
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                                label="Opening Price *"
                                hint="example of helper text only on focus"
                                type="number"
                                v-model = 'trade.openingPrice'
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                              label="Quantity *"
                              hint="example of helper text only on focus"
                              type="number"
                              v-model = 'trade.quantity'
                              required
                            ></v-text-field>
                        </v-col>
                        
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                                label="Closing Date"
                                type="date"
                                v-model = 'trade.closingDate'
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                                label="Closing Price"
                                hint="example of helper text only on focus"
                                type="number"
                                v-model = 'trade.closingPrice'
                            ></v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-text-field
                                label="Stop Loss"
                                hint="example of helper text only on focus"
                                type="number"
                                v-model = 'trade.stopLoss'
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                <small> * indicates required </small>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    text
                    v-on:click="handleCloseForm('closed')"
                >
                    Close
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="handleSaveTrade()"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        errorMessage: ''
    }),
    computed: {
        show: function() {
            return this.showForm;
        }
    },
    props: {
        trade: Object,
        showForm: false
    },
    methods: {
        handleCloseForm: function(status) {
            this.$emit('on-form-update', status);
        },
        handleSaveTrade: function() {
            let endpoint = '/api/1/trades/'
            let method = 'post';
            this.errorMessage = '';
            
            if (this.trade.id != 0) {
                endpoint = '/api/1/trades/'+this.trade.id
                method = 'put';
            }
            
            axios({
                'method': method,
                'url': endpoint,
                'data': {
                    'trade': this.trade
                }
            })
            .then(response => {
                let serverResponse = response.data;
                
                if (serverResponse.code != 200) {
                    serverResponse.message.forEach(error => {
                        this.errorMessage += error +'<br/>';
                    });
                } else {
                    this.$emit('on-form-update', 'updated');
                }
            })
        }
    }
}
    
</script>