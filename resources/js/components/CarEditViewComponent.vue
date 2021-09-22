<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ isEdit ? 'Edit' : 'View' }} Car
                        <router-link class="float-right" to="/cars">
                            Cars
                        </router-link>
                    </div>

                    <div class="card-body">
                        <form class="form" @submit.prevent="saveCar">
                            <div class="form-group">
                                <label>Make</label>
                                <input type="text" class="form-control" name="make" v-model="car.make" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>Model</label>
                                <input type="text" class="form-control" name="model" v-model="car.model" :disabled="!isEdit" />
                            </div>

                            <div class="form-group">
                                <label>Year</label>
                                <input type="number" class="form-control" name="year" v-model="car.year" :disabled="!isEdit" />
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
                            <div class="section">
                                <h5>Address</h5>
                                <div class="form-group">
                                    {{ address.address }}<br>
                                    {{ address.city }}<br>
                                    {{ address.country }}<br>
                                    {{ address.postal_code }}
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
            car: {},
            address: {},
            owner: {},
            action: '',
        }
    },
    created: function() {
        this.getCar();
        this.action = this.$route.params.action;
    },
    computed: {
        isEdit: function () {
            return this.action === 'edit';
        }
    },
    methods: {
        getCar: function() {
            axios.get(`/car/${this.$route.params.id}`).then(function(res) {
                this.car = res.data.car;
                this.owner = res.data.owner;
                this.address = res.data.address;
            }.bind(this));
        },
        saveCar: function() {
            const payload = {
                make: this.car.make,
                model: this.car.model,
                year: this.car.year
            };

            axios.put(`/car/${this.car.id}`, payload)
                .then(function(res) {
                    this.$router.push('/cars');
                }.bind(this));
        }
    }
}
</script>
