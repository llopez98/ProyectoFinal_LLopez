<template>
    <sales-order-component />
</template>
  
<script>
const SalesOrderComponent = () => import('@/components/SalesOrderComponent.vue');
//import SalesOrderComponent from '@/components/SalesOrderComponent.vue';

export default {
    name: 'SalesOrderView',

    components: {
        SalesOrderComponent,
    },
}
</script>