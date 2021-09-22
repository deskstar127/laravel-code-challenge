<template>
    <div>
        <div class="card-group">
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Average Addresses:</h6>
                    <p class="card-text blue-text"><span class="ml-2" style="font-size: 30px;">{{ stats.avg_addresses }}</span></p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Average Cars:</h6>
                    <p class="card-text blue-text"><span class="ml-2" style="font-size: 30px;">{{ stats.avg_cars }}</span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stats: {}
        }
    },
    methods: {
        getOwnerStats: function () {
            axios.get('/owner/stats').then(function (res) {
                if (res.data && res.data[0]) {
                    this.stats = res.data[0];
                }
            }.bind(this));
        }
    },
    created: function () {
        this.getOwnerStats()
    }
}
</script>
