import { isLoggedIn, logOut } from './shared/utils/auth';

export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        },
        user: {},
        username: null,
        isLoggedIn: false
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready(state) {
            return function (id) {
                return state.basket.items.reduce(
                    (result, item) => result || item.bookable.id == id,
                    false
                );
            }
        },
        username: (state) => state.user.name
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        setBasket(state, payload) {
            state.basket = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload) {
            state.basket.items = state.basket.items.filter(item => item.bookable.id != payload);
        },
        setUser(state, payload) {
            state.user = payload;
        },
        setLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: {
        loadStoredState({ commit }) {
            const lastSearch = localStorage.getItem('lastSearch');
            if (lastSearch) {
                commit('setLastSearch', JSON.parse(lastSearch));
            }

            const basket = localStorage.getItem('basket');
            if (basket) {
                commit('setBasket', JSON.parse(basket));
            }

            commit('setLoggedIn', isLoggedIn());
        },
        setLastSearch(context, payload) {
            context.commit('setLastSearch', payload);
            localStorage.setItem('lastSearch', JSON.stringify(payload));
        },
        addToBasket(context, payload) {
            context.commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(context.state.basket));
        },
        removeFromBasket(context, payload) {
            context.commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(context.state.basket));
        },
        clearBasket(context, payload) {
            context.commit('setBasket', { items: [] });
            localStorage.setItem('basket', JSON.stringify(context.state.basket));
        },
        async loadUser({ commit, dispatch }) {
            if (isLoggedIn()) {
                try {
                    const user = (await axios.get(`/user`)).data;

                    commit('setUser', user);
                    commit('setLoggedIn', true);
                } catch (error) {
                    dispatch('logout');
                }
            }
        },
        logout({ commit }) {
            commit('setUser', {});
            commit('setLoggedIn', false);
            logOut();
        }
    }
}