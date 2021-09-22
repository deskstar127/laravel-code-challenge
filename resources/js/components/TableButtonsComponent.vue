<template>
    <div>
        <button class="btn btn-primary" @click="viewRow">View</button>
        <button class="btn btn-primary" @click="editRow">Edit</button>
        <button class="btn btn-danger" @click="deleteRow">Delete</button>
        <table-delete-component :ref="`delete-confirmation-${row.id}`" @confirm="deleteConfirm" @cancel="deleteCancel" />
    </div>
</template>

<script>
import TableDeleteComponent from "./TableDeleteComponent";
export default {
    components: { TableDeleteComponent },
    props: {
        row: {
            type: Object,
            required: true
        }
    },
    data() {
        return {

        }
    },
    methods: {
        editRow: function() {
            if (this.row.type === 'address') {
                this.$router.push(`/${this.row.type}es/${this.row.id}/edit`);
            } else {
                this.$router.push(`/${this.row.type}s/${this.row.id}/edit`);
            }
        },
        viewRow: function() {
            if (this.row.type === 'address') {
                this.$router.push(`/${this.row.type}es/${this.row.id}/view`);
            } else {
                this.$router.push(`/${this.row.type}s/${this.row.id}/view`);
            }
        },
        deleteRow: function() {
            const message = `Are you sure to delete this row in ${this.row.type} table?`;
            this.$refs[`delete-confirmation-${this.row.id}`].show(message);
        },
        deleteConfirm: function() {
            axios.delete(`/${this.row.type}/${this.row.id}`)
                .then(function(res) {
                    this.$notify('Deleted successfully');

                    if (this.row.type === 'address') {
                        this.$router.go(`/${this.row.type}es`);
                    } else {
                        this.$router.go(`/${this.row.type}s`);
                    }
                }.bind(this))
                .catch(function(error) {
                    this.$notify('Unknown error');
                }.bind(this))
                .finally(function() {
                    this.message = '';
                    this.$refs[`delete-confirmation-${this.row.id}`].close();
                }.bind(this));
        },
        deleteCancel: function() {
            this.message = '';
            this.$refs[`delete-confirmation-${this.row.id}`].close();
        }
    }
}
</script>
