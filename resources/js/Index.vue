<template>
  <div>
    <nav class="navbar navbar-expand-md bg-white border-bottom navbar-light">
      <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }">
        Home
      </router-link>

      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'basket' }" v-if="isLoggedIn">
            <span class="badge badge-secondary" v-if="itemsInBasket">
              {{ itemsInBasket }}
            </span>
            <i class="fas fa-shopping-basket fa-lg"></i>
          </router-link>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            data-toggle="dropdown"
            v-if="isLoggedIn"
          >
            {{ username }}
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <li class="nav-item">
              <a class="nav-link" href="#" @click="logout">Log out</a>
            </li>
          </div>
        </li>

        <li class="nav-item" v-if="!isLoggedIn">
          <router-link class="nav-link" :to="{ name: 'register' }">
            Register
          </router-link>
        </li>
        <li class="nav-item" v-if="!isLoggedIn">
          <router-link class="nav-link" :to="{ name: 'login' }">
            Log in
          </router-link>
        </li>
      </ul>
    </nav>

    <div class="container my-4 px-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      isLoggedIn: "isLoggedIn"
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket",
      username: "username"
    })
  },
  methods: {
    async logout() {
      try {
        await axios.post(`/logout`);
        this.$store.dispatch("logout");
      } catch (error) {
        this.$store.dispatch("logout");
      }
    }
  }
};
</script>