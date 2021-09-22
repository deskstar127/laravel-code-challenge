<template>
    <div ref="modal" class="modal fade " tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="text-left">{{ message }}</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" @click="confirm">Delete</button>
                    <button class="btn btn-primary" @click="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: ''
        }
    },
    methods: {
        show: function(message) {
            this.message = message;
            $(this.$refs.modal).modal('show');

        },
        close: function() {
            $(this.$refs.modal).modal('hide');
        },
        confirm: function() {
            this.$emit('confirm');
        },
        cancel: function() {
            $(this.$refs.modal).modal('hide');
            this.$emit('cancel');
        }
    }
}
</script>
