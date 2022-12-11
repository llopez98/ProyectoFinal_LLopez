<template>
    <ProductComponent />
</template>
  
<script>
const ProductComponent = () => import ('@/components/ProductComponent.vue');
//import ProductComponent from '@/components/ProductComponent.vue';

export default {
    name: 'ProductView',

    components: {
        ProductComponent,
    },
}
</script>
  