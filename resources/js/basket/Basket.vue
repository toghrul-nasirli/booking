<template>
  <div>
    <success v-if="success">Thanks for your purchase!</success>
    <div class="row" v-else>
      <div class="col-md-8" v-if="itemsInBasket">
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="first_name">First name</label>
            <input
              class="form-control"
              type="text"
              id="first_name"
              name="first_name"
              v-model="customer.first_name"
              :class="[{ 'is-invalid': errorFor('customer.first_name') }]"
            />
            <v-errors :errors="errorFor('customer.first_name')"></v-errors>
          </div>

          <div class="col-md-6 form-group">
            <label for="last_name">Last name</label>
            <input
              class="form-control"
              type="text"
              id="last_name"
              name="last_name"
              v-model="customer.last_name"
              :class="[{ 'is-invalid': errorFor('customer.last_name') }]"
            />
            <v-errors :errors="errorFor('customer.last_name')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-12 form-group">
            <label for="email">Email</label>
            <input
              class="form-control"
              type="email"
              id="email"
              name="email"
              v-model="customer.email"
              :class="[{ 'is-invalid': errorFor('customer.email') }]"
            />
            <v-errors :errors="errorFor('customer.email')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="street">Street</label>
            <input
              class="form-control"
              type="text"
              id="street"
              name="street"
              v-model="customer.street"
              :class="[{ 'is-invalid': errorFor('customer.street') }]"
            />
            <v-errors :errors="errorFor('customer.street')"></v-errors>
          </div>
          <div class="col-md-6 form-group">
            <label for="city">City</label>
            <input
              class="form-control"
              type="text"
              id="city"
              name="city"
              v-model="customer.city"
              :class="[{ 'is-invalid': errorFor('customer.city') }]"
            />
            <v-errors :errors="errorFor('customer.city')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="country">Country</label>
            <input
              class="form-control"
              type="text"
              id="country"
              name="country"
              v-model="customer.country"
              :class="[{ 'is-invalid': errorFor('customer.country') }]"
            />
            <v-errors :errors="errorFor('customer.country')"></v-errors>
          </div>
          <div class="col-md-4 form-group">
            <label for="state">State</label>
            <input
              class="form-control"
              type="text"
              id="state"
              name="state"
              v-model="customer.state"
              :class="[{ 'is-invalid': errorFor('customer.state') }]"
            />
            <v-errors :errors="errorFor('customer.state')"></v-errors>
          </div>
          <div class="col-md-2 form-group">
            <label for="zip">Zip code</label>
            <input
              class="form-control"
              type="text"
              id="zip"
              name="zip"
              v-model="customer.zip"
              :class="[{ 'is-invalid': errorFor('customer.zip') }]"
            />
            <v-errors :errors="errorFor('customer.zip')"></v-errors>
          </div>
        </div>
        <hr />

        <button
          class="btn btn-large btn-secondary btn-block mb-5"
          @click="book"
          :disabled="loading"
        >
          Book Now!
        </button>
      </div>
      <div class="col-md-8" v-else>
        <div class="jumbotron jumbotron-fluid text-center">
          <h1 class="text-secondary">Your basket is empty!</h1>
        </div>
      </div>

      <div class="col-md-4">
        <div class="d-flex justify-content-between">
          <h6 class="text-uppercase text-secondary font-weight-bold">
            Your Basket
          </h6>
          <h6 class="badge badge-secondary text-uppercase pt-1">
            <span v-if="itemsInBasket">Items {{ itemsInBasket }}</span>
            <span v-else>EMPTY</span>
          </h6>
        </div>

        <transition-group>
          <div v-for="item in basket" :key="item.bookable.id">
            <div class="d-flex justify-content-between border-top pt-2">
              <span>
                <router-link
                  :to="{ name: 'bookable', params: { id: item.bookable.id } }"
                  class="text-dark font-weight-bold"
                >
                  {{ item.bookable.title }}
                </router-link>
              </span>
              <span class="font-weight-bold"> ${{ item.price.total }} </span>
            </div>

            <div class="d-flex justify-content-between py-2">
              <small> From {{ item.dates.from }} </small>
              <small> To {{ item.dates.to }} </small>
            </div>

            <div class="text-right py-2">
              <button
                class="btn btn-sm btn-outline-secondary"
                @click="$store.dispatch('removeFromBasket', item.bookable.id)"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      customer: {
        first_name: null,
        last_name: null,
        email: null,
        street: null,
        city: null,
        country: null,
        state: null,
        zip: null
      },
      bookingAttempted: false,
      loading: false
    };
  },
  computed: {
    ...mapState({
      basket: state => state.basket.items
    }),
    ...mapGetters(["itemsInBasket"]),
    success() {
      return !this.loading && this.itemsInBasket == 0 && this.bookingAttempted;
    }
  },
  methods: {
    async book() {
      this.bookingAttempted = false;
      this.loading = true;
      this.errors = null;

      try {
        await axios.post(`/api/checkout`, {
          customer: this.customer,
          bookings: this.basket.map(basketItem => ({
            bookable_id: basketItem.bookable.id,
            from: basketItem.dates.from,
            to: basketItem.dates.to
          }))
        });

        this.$store.dispatch("clearBasket");
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }

      this.loading = false;
      this.bookingAttempted = true;
    }
  }
};
</script>


<style scoped>
h6.badge {
  font-size: 80%;
}
</style>-