<template>
  <div class="p-3">
    <h6 class="text-uppercase text-secondary font-weight-bold pt-4">
      Review List
    </h6>

    <div v-if="loading">Loading...</div>
    <div v-else>
      <div
        class="border-bottom d-none d-md-block"
        v-for="(review, index) in reviews"
        :key="index"
      >
        <div class="row pt-4">
          <div class="col-md-6">Toghrul Nasirli</div>
          <div class="col-md-6 d-flex justify-content-end">
            <star-rating :value="review.rating"></star-rating>
          </div>
        </div>
        <div class="row">
          <div class="col-12">{{ review.created_at | fromNow }}</div>
        </div>
        <div class="row py-4">
          <div class="col-12">{{ review.content }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { bookableId: [String, Number] },
  data() {
    return {
      reviews: null,
      loading: false
    };
  },
  created() {
    this.loading = true;

    axios
      .get(`/api/bookables/${this.bookableId}/reviews`)
      .then(response => (this.reviews = response.data.data))
      .then(() => (this.loading = false));
  }
};
</script>