import { createStore } from 'vuex';

const store = createStore({
    state: {
        isLoggedIn: false,
        token: null,
        user: null, // New state to hold user information
    },
    mutations: {
        SET_LOGGED_IN(state, payload) {
            state.isLoggedIn = payload.isLoggedIn;
            state.token = payload.token;
            state.user = payload.user; // Store user information
        },
        SET_USER(state, user) {
            state.user = user; // Mutation to set user data independently
        },
    },
    actions: {
        async login({ commit }, token) {
            // Assume token has been validated and is valid here.
            commit('SET_LOGGED_IN', { isLoggedIn: true, token });

            // Fetch user data from an API endpoint and commit it
            try {
                const response = await fetch('/api/auth-user', {
                    headers: {
                        Authorization: `Bearer ${token}`, // Include token if required
                    },
                });
                const userData = await response.json();
                commit('SET_USER', userData); // Commit the user data to state
            } catch (error) {
                console.error('Failed to fetch user info:', error);
            }
        },
        logout({ commit }) {
            commit('SET_LOGGED_IN', { isLoggedIn: false, token: null, user: null });
            localStorage.removeItem('token');
        },
        async initializeAuth({ commit }) {
            const token = localStorage.getItem('token');
            if(token){
                commit('SET_LOGGED_IN', {isLoggedIn: true, token});

                try {
                    const response = await fetch('/api/auth-user', {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                    const userData = await response.json();
                    commit('SET_USER', userData); // Set user data in state
                } catch (error) {
                    console.error('Failed to fetch user info during initialization:', error);
                }
            }
        }
    },
    getters: {
        isLoggedIn: (state) => state.isLoggedIn,
        user: (state) => state.user, // Getter to access user info
        token: (state) => state.token,
    },
});

export default store;
