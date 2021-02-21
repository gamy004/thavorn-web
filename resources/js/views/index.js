export const HOME = () =>
    import(/* webpackChunkName: "thavorn-home" */ "./home");
// export const SIGNIN = () => import( /* webpackChunkName: "thavorn-auth" */ 'auth/views/login');
// export const SIGNUP = () => import( /* webpackChunkName: "thavorn-auth" */ 'auth/views/register');
// export const PASSWORD = {
//     EMAIL: () => import( /* webpackChunkName: "thavorn-auth" */ 'auth/views/passwords/email'),
//     RESET: () => import( /* webpackChunkName: "thavorn-auth" */ 'auth/views/passwords/reset')
// };

// export const COMPANY = () => import( /* webpackChunkName: "thavorn-proj" */ 'company/views/index');

export const PAWN = {
    CREATE: () =>
        import(/* webpackChunkName: "thavorn-pawn-create" */ "./pawn/create"),
    EXTEND: () =>
        import(/* webpackChunkName: "thavorn-pawn-extend" */ "./pawn/extend"),
    CLOSE: () =>
        import(/* webpackChunkName: "thavorn-pawn-close" */ "./pawn/close")        
};

export const DATA = {
    CUSTOMER: () =>
        import(/* webpackChunkName: "thavorn-pawn-create" */ "./data/customer"),
    PAWN: () =>
        import(/* webpackChunkName: "thavorn-pawn-extend" */ "./data/pawn"),
};

// export const SERVICE = {
//     INDEX: () => import( /* webpackChunkName: "thavorn-service-index" */ 'service/views/index')
// }

// export const ADMIN = {
//     HOME: () => import( /* webpackChunkName: "thavorn-admin-home-index" */ 'admin/home/views/index'),
//     USER: () => import( /* webpackChunkName: "thavorn-admin-user-index" */ 'admin/user/views/index'),
//     COMPANY: () => import( /* webpackChunkName: "thavorn-admin-company-index" */ 'admin/company/views/index'),
//     DRIVETYPE: {
//         INDEX: () => import( /* webpackChunkName: "thavorn-admin-drivetype-index" */ 'admin/drivetype/views/index'),
//         SHOW: () => import( /* webpackChunkName: "thavorn-admin-drivetype-show" */ 'admin/drivetype/views/show')
//     },
//     MACHINE: {
//         INDEX: () => import( /* webpackChunkName: "thavorn-admin-machine-index" */ 'admin/machine/views/index'),
//         SHOW: () => import( /* webpackChunkName: "thavorn-admin-machine-show" */ 'admin/machine/views/show'),
//     },
//     SERVICE: {
//         INDEX: () => import( /* webpackChunkName: "thavorn-admin-service-index" */ 'admin/service/views/index'),
//         SHOW: () => import( /* webpackChunkName: "thavorn-admin-service-show" */ 'admin/service/views/show'),
//     },
// }
