import VueRouter from 'vue-router'
// Views
//import About from '../views/About'
import Register from '../views/Register'
import Login from '../views/Login'
import Dashboard from '../views/user/Dashboard'
import Tanks from '../views/Tanks'
import Home from '../views/Home'
import ForgotPassword from '../views/ForgotPassword'
import ResetPasswordForm from '../views/ResetPasswordForm'
//import AdminDashboard from './pages/admin/Dashboard'
// Routes
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      auth: undefined
    }
  },
//   {
//     path: '/about',
//     name: 'about',
//     component: About,
//     meta: {
//       auth: undefined
//     }
//   },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,

  },
  // USER ROUTES
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
        }
    },
    {
        path: '/tanks',
        name: 'tanks',
        component: Tanks,
        props: true,
        meta: {
            auth: true
        }
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ForgotPassword,
        meta: {
          auth:false
        }
    },
    {
        path: '/reset-password/:token',
        name: 'reset-password-form',
        component: ResetPasswordForm,
        meta: {
          auth:false
        }
    }
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
export default router
