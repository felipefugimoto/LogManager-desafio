import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
   
    {
      path: '/produto',
      name: 'produto',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Produto.vue'),
    },
    {
      path: '/mercadoLivre',
      name: 'mercadoLivre',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/MercadoLivre.vue'),
    },
    {
      path: '/tokenManager',
      name: 'tokenManager',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/TokenManager.vue'),
    },
    {
      path: '/callback',
      name: 'tokencallbackManager',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Callback.vue'),
    },
    {
      path: '/atualizarToken',
      name: 'atualizarToken',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AtualizarToken.vue'),
    },
  ],
})

export default router
