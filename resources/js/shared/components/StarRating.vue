<template>
  <div class="d-flex">
    <i
      class="fas fa-star"
      v-for="star in fullStars"
      :key="'full' + star"
      @click="$emit('input', star)"
    ></i>
    <i class="fas fa-star-half-alt" v-if="halfStar"></i>
    <i
      class="far fa-star"
      v-for="star in emptyStars"
      :key="'empty' + star"
      @click="$emit('input', fullStars + star)"
    ></i>
  </div>
</template>

<script>
export default {
  props: {
    value: Number
  },
  computed: {
    fullStars() {
      return Math.round(this.value);
    },
    halfStar() {
      const fraction = Math.round(this.value - Math.floor(this.value)) * 100;

      return fraction > 0 && fraction <= 50;
    },
    emptyStars() {
      return 5 - Math.ceil(this.value);
    }
  }
};
</script>