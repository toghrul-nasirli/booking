<template>
  <div>
    <div
      class="invalid-feedback"
      v-for="(error, index) in errors"
      :key="key(index)"
    >
      {{ error }}
    </div>
  </div>
</template>

<script>
export default {
  props: ["errors"],
  methods: {
    key(index) {
      return `error_${index}_${Math.random()}`;
    }
  }
};
</script>

<style scoped>
.form-control.is-invalid ~ div > .invalid-feedback {
  display: block;
}
</style>
