import Vue from 'vue';
import Router from 'vue-router';
import store from '../common/Store';

// route vue file list
import Home from './dashboard/Home';
import Users from './users/Users';
import UsersLists from './users/components/UserLists';
import UsersFormAdd from './users/components/UserFormAdd';
import UserFormEdit from './users/components/UserFormEdit';
import GroupLists from './users/components/GroupLists';
import GroupFromAdd from './users/components/GroupFromAdd';
import GroupFromEdit from './users/components/GroupFromEdit';
import PermissionLists from './users/components/PermissionLists';
import PermissionFormAdd from './users/components/PermissionFormAdd';
import PermissionFormEdit from './users/components/PermissionFormEdit';
import Signs from './signs/Signs';
import SignLists from './signs/components/SignLists';
import SignFormAdd from './signs/components/SignFormAdd';
import SignFormEdit from './signs/components/SignFormEdit';

import Files from './files/Files';
import Settings from './settings/Settings';

Vue.use(Router);

const router = new Router({
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
        },
        {
            name: 'dashboard',
            path: '/dashboard',
            component: Home,
        },
        {
            path: '/users',
            component: Users,
            children: [
                {
                    path:'/',
                    name:'users.list',
                    component: UsersLists
                },
                {
                    path:'create',
                    name:'users.create',
                    component: UsersFormAdd
                },
                {
                    path:'edit/:id',
                    name:'users.edit',
                    component: UserFormEdit,
                    props: (route) => ({propUserId: route.params.id}),
                },
                {
                    path:'groups',
                    name:'users.groups.list',
                    component: GroupLists
                },
                {
                    path:'groups/create',
                    name:'users.groups.create',
                    component: GroupFromAdd
                },
                {
                    path:'groups/edit/:id',
                    name:'users.groups.edit',
                    component: GroupFromEdit,
                    props: (route) => ({propGroupId: route.params.id}),
                },
                {
                    path:'permissions',
                    name:'users.permissions.list',
                    component: PermissionLists
                },
                {
                    path:'permissions/create',
                    name:'users.permissions.create',
                    component: PermissionFormAdd
                },
                {
                    path:'permissions/edit/:id',
                    name:'users.permissions.edit',
                    component: PermissionFormEdit,
                    props: (route) => ({propPermissionId: route.params.id}),
                },
            ]
        },
        {
            name: 'files',
            path: '/files',
            component: Files,
        },
        {
            name: 'settings',
            path: '/settings',
            component: Settings,
        },
        {
            path: '/signs',
            component: Signs,
            children: [
                {
                    path:'/',
                    name:'signs.list',
                    component: SignLists
                },
                {
                    path:':page',
                    name:'signs.page',
                    component: SignLists,

                },
                {
                    path:'create',
                    name:'signs.create',
                    component: SignFormAdd
                },
                {
                    path:'edit/:id',
                    name:'signs.edit',
                    component: SignFormEdit,
                    props: (route) => ({propSignId: route.params.id}),
                }
            ]
        },
    ],
});

router.beforeEach((to, from, next) => {
    store.commit('showLoader');
    next();
});

router.afterEach((to, from) => {
    setTimeout(()=>{
        store.commit('hideLoader');
    },1000);
});

export default router;