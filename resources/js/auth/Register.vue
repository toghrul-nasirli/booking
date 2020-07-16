<template>
  <div class="w-50 m-auto">
    <div class="card card-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input
          class="form-control"
          type="text"
          id="name"
          name="name"
          placeholder="Enter your name"
          v-model="user.name"
          @keyup.enter="register"
          :class="[{ 'is-invalid': errorFor('name') }]"
        />
        <v-errors :errors="errorFor('name')"></v-errors>
      </div>
      <div class="form-group">
        <label for="email">E-Mail Address</label>
        <input
          class="form-control"
          type="email"
          id="email"
          name="email"
          placeholder="Enter your e-mail"
          v-model="user.email"
          @keyup.enter="register"
          :class="[{ 'is-invalid': errorFor('email') }]"
        />
        <v-errors :errors="errorFor('email')"></v-errors>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          class="form-control"
          type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          v-model="user.password"
          @keyup.enter="register"
          :class="[{ 'is-invalid': errorFor('password') }]"
        />
        <v-errors :errors="errorFor('password')"></v-errors>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          class="form-control"
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          placeholder="Confirm your password"
          v-model="user.password_confirmation"
          @keyup.enter="register"
          :class="[{ 'is-invalid': errorFor('password_confirmation') }]"
        />
        <v-errors :errors="errorFor('password_confirmation')"></v-errors>
      </div>

      <button
        class="btn btn-secondary btn-lg btn-block"
        @click="register"
        :disabled="loading"
      >
        Register
      </button>
      <hr />

      <span>
        Already have an account?
        <router-link class="font-weight-bold" :to="{ name: 'login' }">
          Log in
        </router-link>
      </span>
    </div>
  </div>
</template>

<script>
import { logIn } from "../shared/utils/auth";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      loading: false
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.errors = null;

      try {
        const response = await axios.post("/register", this.user);

        if (response.status == 201) {
          logIn();

          this.$store.dispatch("loadUser");
          this.$router.push({ name: "home" });
        }
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }

      this.loading = false;
    }
  }
};
</script>