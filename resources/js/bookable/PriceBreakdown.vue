<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bold">
      price breakdown
    </h6>

    <div
      v-for="(days, price) in price.breakdown"
      :key="price"
      class="d-flex justify-content-between border-top border-bottom py-2"
    >
      <u>${{ price }} x {{ days }} nights</u>
      <span>${{ days * price }}</span>
    </div>

    <div class="d-flex justify-content-between font-weight-bold pt-2">
      <span>Total</span>
      <span>${{ price.total }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: { price: Object }
};
</script>