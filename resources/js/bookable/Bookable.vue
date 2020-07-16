<template>
  <div>
    <div class="row">
      <div class="col-md-8 pb-4">
        <div class="card">
          <div class="card-body">
            <div v-if="!loading">
              <h2>{{ bookable.title }}</h2>
              <hr />
              <article>{{ bookable.description }}</article>
            </div>
            <div v-else>Loading...</div>
          </div>
        </div>

        <review-list :bookable-id="this.$route.params.id"></review-list>
      </div>
      <div class="col-md-4">
        <availability
          class="mb-4 mx-2"
          @availability="checkPrice($event)"
          :bookable-id="this.$route.params.id"
        ></availability>

        <div class="mx-2">
          <transition>
            <price-breakdown
              v-if="price"
              :price="price"
              class="mb-4"
            ></price-breakdown>
          </transition>

          <transition>
            <button
              class="btn btn-outline-secondary btn-block"
              v-if="price"
              @click="addToBasket"
              :disabled="inBasketAlready"
            >
              Book Now
            </button>
          </transition>

          <transition>
            <button
              class="btn btn-outline-secondary btn-block"
              v-if="inBasketAlready"
              @click="removeFromBasket"
            >
              Remove From Basket
            </button>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";

import { mapState } from "vuex";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown
  },
  data() {
    return {
      bookable: null,
      price: null,
      loading: false
    };
  },
  created() {
    this.loading = true;

    axios
      .get(`/api/bookables/${this.$route.params.id}`)
      .then(response => (this.bookable = response.data.data))
      .then(() => (this.loading = false));
  },
  computed: {
    ...mapState({
      lastSearch: "lastSearch"
    }),
    inBasketAlready() {
      if (this.bookable == null) {
        return false;
      }

      return this.$store.getters.inBasketAlready(this.bookable.id);
    }
  },
  methods: {
    async checkPrice(hasAvailability) {
      if (!hasAvailability) {
        this.price = null;
        return;
      }

      try {
        this.price = (
          await axios.get(
            `/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
          )
        ).data.data;
      } catch (error) {
        this.price = null;
      }
    },
    addToBasket() {
      this.$store.dispatch("addToBasket", {
        bookable: this.bookable,
        price: this.price,
        dates: this.lastSearch
      });
    },
    removeFromBasket() {
      this.$store.dispatch("removeFromBasket", this.bookable.id);
    }
  }
};
</script>
