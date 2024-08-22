import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import ProjectView from '../views/ProjectView.vue'
import WorkSpaceView from '../views/WorkSpaceView.vue'
import SearchView from '../views/SearchView.vue'
import ProfileView from '../views/ProfileView.vue'
import SettingView from '../views/SettingView.vue'
import NotFoundView from '../views/NotFoundView.vue'
import MemberView from '../views/MemberView.vue'

import { useToken } from '../stores/'

const [token, setToken] = useToken()

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/search/:keyword',
            name: 'search',
            component: SearchView
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
            path: '/profile/:uid',
            name: 'profile',
            component: ProfileView
        },
        {
            path: '/modify-member/:id',
            name: 'editMember',
            component: MemberView
        },
        {
            path: '/setting/:id',
            name: 'setting',
            component: SettingView
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'NotFound',
            component: NotFoundView
        }
    ]
})

const authenticateRoute = ['test', 'workspace', 'project']

router.beforeEach(async (to, from) => {
    if (!token.value && authenticateRoute.includes(to.name)) {
        return { name: 'login' }
    }
})

export default router
