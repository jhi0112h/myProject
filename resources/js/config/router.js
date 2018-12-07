import Vue from 'vue';
import Router from 'vue-router';
import store from '../vuex/Store';

// route vue file list
import Home from '../admin/dashboard/Home';
import Users from '../admin/users/Users';
import UsersLists from '../admin/users/components/UserLists';
import UsersFormAdd from '../admin/users/components/UserFormAdd';
import UserFormEdit from '../admin/users/components/UserFormEdit';
import GroupLists from '../admin/users/components/GroupLists';
import GroupFromAdd from '../admin/users/components/GroupFromAdd';
import GroupFromEdit from '../admin/users/components/GroupFromEdit';
import PermissionLists from '../admin/users/components/PermissionLists';
import PermissionFormAdd from '../admin/users/components/PermissionFormAdd';
import PermissionFormEdit from '../admin/users/components/PermissionFormEdit';
import Signs from '../spa/signs/Signs';
import SignLists from '../spa/signs/components/SignLists';
import SignView from '../spa/signs/components/SignView';
import SignFormAdd from '../spa/signs/components/SignFormAdd';
import SignFormEdit from '../spa/signs/components/SignFormEdit';

import Files from '../admin/files/Files';
import Settings from '../admin/settings/Settings';

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
            name: 'signs',
            component: Signs,
            redirect: 'signs/all',
            children: [
                {
                    path:'all',
                    name:'signs.list',
                    component: SignLists
                },
                {
                    path:'all/:id',
                    name:'signs.view',
                    component: SignView,
                    props: (route) => ({propSignId: route.params.id}),
                },
                {
                    path:'not',
                    name:'signs.list2',
                    component: SignLists
                },
                {
                    path:'not/:id',
                    name:'signs.view',
                    component: SignView,
                    props: (route) => ({propSignId: route.params.id}),
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
    store.commit('hideLoader');
});

export default router;