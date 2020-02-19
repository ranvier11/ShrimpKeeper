<template>
    <TankButton
    name="Add Tank"
    @clicked="cardModal()" @reload="closeModal()"/>

</template>

<script>
import TankButton from '../js/components/TankButton.vue'
import TankModalTemplate from './TankModalTemplate.vue'

    export default {
        props: {
            userId: {
                type: Number
            },
            tankId: {
                type: Number
            }
        },
        methods: {
            cardModal() {
                this.$buefy.modal.open({
                    parent: this,
                    component: TankModalTemplate ,
                    hasModalCard: true,
                    //customClass: 'custom-class custom-class-2',
                    trapFocus: true,
                    props: {
                        userId: this.userId,
                    }
                })
            },
            closeModal() {
                console.log('close');
            }
        },
        components: {
            TankButton,
            TankModalTemplate
        }
    }
</script>
<style>
.datepicker .datepicker-table .datepicker-cell{
    text-align:center;
    vertical-align:middle;
    display:table-cell;
    border-radius:4px;
    padding:.5rem .75rem
}
.datepicker .datepicker-table .datepicker-body .datepicker-cell.is-today{
    border: 1px solid blue;
}
.datepicker .datepicker-table .datepicker-body .datepicker-cell.is-unselectable{
    color: #b5b5b5;
}
.tendown {
    padding-top:15px;
}
</style>
