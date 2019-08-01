<template>
    <div class="center_box cb">
        <div class="uo_tabs cf">
            <a href="#"><span>profile</span></a>
            <a href="#"><span>Reviews</span></a>
            <a href="#"><span>orders</span></a>
            <a href="#" class="active"><span>My Address</span></a>
            <a href="#"><span>Settings</span></a>
        </div>
        <div class="page_content bg_gray">
            <div class="uo_header">
                <div class="wrapper cf">
                    <div class="wbox ava">
                        <figure><img src="imgc/user_ava_1_140.jpg" alt="Helena Afrassiabi" /></figure>
                    </div>
                    <div class="main_info">
                        <h1>Helena Afrassiabi</h1>
                        <div class="midbox">
                            <h4>560 points</h4>
                            <div class="info_nav">
                                <a href="#">Get Free Points</a>
                                <span class="sepor"></span>
                                <a href="#">Win iPad</a>
                            </div>
                        </div>
                        <div class="stat">
                            <div class="item">
                                <div class="num">30</div>
                                <div class="title">total orders</div>
                            </div>
                            <div class="item">
                                <div class="num">14</div>
                                <div class="title">total reviews</div>
                            </div>
                            <div class="item">
                                <div class="num">0</div>
                                <div class="title">total gifts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uo_body">
                <div class="wrapper">
                    <div class="uofb cf">
                        <div class="l_col adrs">
                            <h2>Add New Address</h2>

                            <form autocomplete="off" @submit.prevent="save" method="post">
                                <div class="field">
                                    <label>Name *</label>
                                    <input
                                        type="text"
                                        value=""
                                        palceholder=""
                                        class="vl_empty"
                                        v-model="formData.name"
                                        name="name"
                                    />
                                    <span class="error" v-show="errors.name">Field is required</span>
                                </div>
                                <div class="field">
                                    <label>Your city *</label>
                                    <region-select
                                        v-model="formData.city"
                                        country="US"
                                        :region="formData.city"
                                        :regionName=true
                                        placeholder=""
                                    />
                                    <span class="error" v-show="errors.country">Field is required</span>
                                </div>
                                <div class="field">
                                    <label>Your area *</label>
                                    <select v-model="formData.area">
                                        <option class="plh"></option>
                                        <option>Business Bay Area</option>
                                        <option>West Bay Area</option>
                                    </select>
                                    <span class="error" v-show="errors.region">Field is required</span>
                                </div>

                                <div class="field">
                                    <label>Street</label>
                                    <input
                                        type="text"
                                        value=""
                                        palceholder=""
                                        class="vl_empty"
                                        v-model="formData.street"
                                        name="street"
                                    />
                                </div>
                                <div class="field">
                                    <label>House # </label>
                                    <input
                                        type="text"
                                        value=""
                                        palceholder="House Name / Number"
                                        v-model="formData.house_number"
                                        name="house_number"
                                    />
                                </div>

                                <div class="field">
                                    <label class="pos_top">Additional information</label>
                                    <textarea
                                        v-model="formData.additional_information"
                                        name="street"
                                    ></textarea>
                                </div>

                                <div class="field">
                                    <input type="submit" value="add address" class="green_btn" />
                                </div>
                            </form>
                        </div>

                        <div class="r_col">
                            <h2>My Addresses</h2>

                            <div class="uo_adr_list" v-show="show_adresses_list">
                                <div class="item" v-for="(value, key) in adresses_list" :key="value.id">
                                    <h3>{{ value.name }}</h3>
                                    <p>{{ value.city }},
                                        {{ value.area }},
                                        {{ value.street }},
                                        {{ value.house_number }},
                                        <br/>
                                        {{value.additional_information}}
                                    </p>
                                    <div class="actbox">
                                        <a href="" class="bcross" @click.prevent="remove(value.id)"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="uo_adr_list" v-show="!show_adresses_list">
                                ADDRESSES NOT FOUND
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formData: {
                    name: null,
                    street: null,
                    house_number: null,
                    additional_information: null,
                    area: '',
                    city: '',
                },
                errors: {
                    name: false,
                    area: false,
                    city: false,
                },
                adresses_list: [],
                show_adresses_list: false

            }
        },
        created () {
            this.fetchData();
            console.log(this.adresses_list.lenght);
        },
        methods: {
            save() {
                var self = this;
                if (!this.checkForm(this.formData)) {
                    axios.post("/add", this.formData)
                    .then(function(response) {
                        let data = response.data;
                        if (data.success) {
                            for (let key in self.formData) {
                                let fieldName = key;
                                if (fieldName == 'country' || fieldName == 'city') {
                                    self.formData[fieldName] = '';
                                } else {
                                    self.formData[fieldName] = null;
                                }
                            }
                            self.fetchData();
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
                }
            },
            checkForm(fields) {
                let counter = 0;

                if (!fields.name) {
                    this.errors.name = true;
                    counter++;
                } else {
                    this.errors.name = false;
                }

                if (!fields.area) {
                    this.errors.area = true;
                    counter++;
                } else {
                    this.errors.area = false;
                }

                if (!fields.city) {
                    this.errors.city = true;
                    counter++;
                } else {
                    this.errors.city = false;
                }

                return counter;
            },
            fetchData() {
                axios.get('/show')
                .then((response) => {
                    let data = response.data;
                    if (data.success) {
                        this.adresses_list = data.data;
                        this.show_adresses_list = true;
                    } else {
                        this.show_adresses_list = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            remove(id) {
                this.axios.delete('/remove/' + id)
                .then((response) => {
                    let data = response.data;
                    if (data.success) {
                        this.fetchData();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>
