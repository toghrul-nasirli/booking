<template>
  <div class="w-50 m-auto">
    <div class="card card-body">
      <div class="form-group">
        <label for="email">E-Mail Address</label>
        <input
          class="form-control"
          type="email"
          id="email"
          name="email"
          placeholder="Enter your e-mail"
          v-model="email"
          @keyup.enter="login"
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
          v-model="password"
          @keyup.enter="login"
          :class="[{ 'is-invalid': errorFor('password') }]"
        />
        <v-errors :errors="errorFor('password')"></v-errors>
      </div>

      <button
        class="btn btn-secondary btn-lg btn-block"
        @click="login"
        :disabled="loading"
      >
        Log In
      </button>
      <hr />

      <span>
        Forgot Password?
        <router-link class="font-weight-bold" :to="{ name: 'home' }">
          Reset Password
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
      email: null,
      password: null,
      loading: false
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = null;

      try {
        await axios.get("/sanctum/csrf-cookie");

        await axios.post("/login", {
          email: this.email,
          password: this.password
        });

        logIn();
        this.$store.dispatch("loadUser");
        this.$router.push({ name: "home" });
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }

      this.loading = false;
    }
  }
};
</script>