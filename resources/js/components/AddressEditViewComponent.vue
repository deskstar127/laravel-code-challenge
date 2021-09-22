<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ isEdit ? 'Edit' : 'View' }} Address
                        <router-link class="float-right" to="/addresses">
                            Addresses
                        </router-link>
                    </div>

                    <div class="card-body">
                        <form class="form" @submit.prevent="saveAddress">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" v-model="address.address" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" v-model="address.city" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" name="country" v-model="address.country" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="text" class="form-control" name="postal_code" v-model="address.postal_code" :disabled="!isEdit" />
                            </div>

                            <button type="submit" class="btn btn-primary" v-if="isEdit">Submit</button>
                        </form>

                        <div class="associated-entities" v-if="!isEdit">
                            <hr />
                            <div class="section">
                                <h5>Owner</h5>
                                <div class="form-group">
                                    {{ owner.first_name }} {{ owner.last_name }}
                                </div>
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
            address: {},
            owner: {},
            action: '',
        }
    },
    created: function() {
        this.getAddress();
        this.action = this.$route.params.action;
    },
    computed: {
        isEdit: function () {
            return this.action === 'edit';
        }
    },
    methods: {
        getAddress: function() {
            axios.get(`/address/${this.$route.params.id}`).then(function(res) {
                this.owner = res.data.owner;
                this.address = res.data.address;
            }.bind(this));
        },
        saveAddress: function() {
            const payload = {
                address: this.address.address,
                city: this.address.city,
                country: this.address.country,
                postal_code: this.address.postal_code
            };

            axios.put(`/address/${this.address.id}`, payload)
                .then(function(res) {
                    this.$router.push('/addresses');
                }.bind(this));
        }
    }
}
</script>
