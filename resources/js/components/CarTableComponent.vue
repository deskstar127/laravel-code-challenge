<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";

export default {
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'Make',
                    field: 'make',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Model',
                    field: 'model',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Year',
                    field: 'year',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Owner',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: ({owner}) => `${owner.first_name} ${owner.last_name}`
                },
                {
                    label: 'Address',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: ({address}) => {
                        return address.address + '<br>' + address.city + '<br>' + address.country + '<br>' + address.postal_code
                    }
                },
                {
                    label: 'Actions',
                    headerAlign: 'right',
                    align: 'right',
                    component: TableButtonsComponent
                }
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true
        }
    },
    methods: {
        showCars: function () {
            axios.get('/car').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showCars()
    }
}
</script>
