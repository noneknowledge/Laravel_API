import { createRouter, createWebHistory } from 'vue-router'

// import CockTailView from '../views/CockTailView.vue'
import HomeView from '../views/HomeView.vue'
import NewView from '../views/NewView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import ProjectView from '../views/ProjectView.vue'
import WorkSpaceView from '../views/WorkSpaceView.vue'
import { useToken } from '../stores/'

const [token, setToken] = useToken()

const router = createRouter({
    // history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/workspace',
            name: 'workspace',
            component: WorkSpaceView
        },
        {
            path: '/test',
            name: 'test',
            component: HomeView
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/project/:id',
            name: 'project',
            component: ProjectView
        },
        {
            path: '/new',
            name: 'new',
            component: NewView
        }
    ]
})

const authenticateRoute = ['dashboard', 'test']

router.beforeEach(async (to, from) => {
    if (!token.value && authenticateRoute.includes(to.name)) {
        return { name: 'login' }
    }
})

export default router
