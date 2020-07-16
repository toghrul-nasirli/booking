<template>
  <div>
    <success v-if="success">
      <h2>
        You've left a
        <router-link
          :to="{
            name: 'bookable',
            params: { id: booking.bookable.id }
          }"
        >
          review
        </router-link>
        , thank you very much!
      </h2>
    </success>
    <fatal-error v-if="error"></fatal-error>

    <div class="row" v-if="!success && !error">
      <div :class="[{ 'col-md-4': twoColumns }, { 'd-none': oneColumn }]">
        <div class="card">
          <div class="card-body">
            <div v-if="loading">Loading...</div>
            <div v-if="hasBooking">
              <p>
                Stayed at
                <router-link
                  :to="{
                    name: 'bookable',
                    params: { id: booking.bookable.id }
                  }"
                >
                  {{ booking.bookable.title }}
                </router-link>
              </p>
              <p>From {{ booking.from }} to {{ booking.to }}</p>
            </div>
          </div>
        </div>
      </div>
      <div :class="[{ 'col-md-8': twoColumns }, { 'col-12': oneColumn }]">
        <div v-if="loading">Loading...</div>
        <div v-else>
          <div v-if="alreadyReviewed">
            <h3>You've already left a review for this booking!</h3>
          </div>
          <div v-else>
            <div class="form-group">
              <label class="text-muted">Select star rating</label>
              <star-rating class="fa-3x" v-model="review.rating"></star-rating>
            </div>
            <div class="form-group">
              <label for="content" class="text-muted">
                Describe your experience
              </label>
              <textarea
                name="content"
                cols="30"
                rows="10"
                class="form-control"
                v-model="review.content"
                :class="[{ 'is-invalid': errorFor('content') }]"
              ></textarea>

              <validation-errors
                :errors="errorFor('content')"
              ></validation-errors>
            </div>

            <button
              class="btn btn-secondary btn-lg btn-block"
              @click="submit"
              :disabled="sending"
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { is404, is422 } from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      review: {
        id: null,
        rating: 0,
        content: null
      },
      existingReview: null,
      booking: null,
      success: false,
      error: false,
      loading: false,
      sending: false
    };
  },
  async created() {
    this.loading = true;
    this.review.id = this.$route.params.id;

    try {
      this.existingReview = (
        await axios.get(`/api/reviews/${this.review.id}`)
      ).data.data;
    } catch (error) {
      if (is404(error)) {
        try {
          this.booking = (
            await axios.get(`/api/booking-by-review/${this.review.id}`)
          ).data.data;
        } catch (error) {
          this.error = !is404(error);
        }
      } else {
        this.error = true;
      }
    }

    this.loading = false;
  },
  computed: {
    alreadyReviewed() {
      return this.hasReview || !this.booking;
    },
    hasReview() {
      return this.existingReview != null;
    },
    hasBooking() {
      return this.booking != null;
    },
    oneColumn() {
      return !this.loading && this.alreadyReviewed;
    },
    twoColumns() {
      return this.loading || !this.alreadyReviewed;
    }
  },
  methods: {
    submit() {
      this.sending = true;
      this.success = false;
      this.errors = null;

      const postRequest = axios
        .post(`/api/reviews`, this.review)
        .then(response => (this.success = response.status == 201))
        .catch(error => {
          if (is422(error)) {
            const errors = error.response.data.errors;

            if (errors["content"] && _.size(errors) == 1) {
              this.errors = errors;
              return;
            }
          }

          this.error = true;
        })
        .then(() => (this.sending = false));
    }
  }
};
</script>
