/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const settingsRoutes = {
  path: '/settings',
  component: Layout,
  redirect: '/settings',
  name: 'Settings',
  alwaysShow: true,
  meta: {
    title: 'settings',
    icon: 'setting',
    permissions: ['view menu administrator'],
  },
  children: [
    /** Categories */
    {
      path: 'categories',
      component: () => import('@/views/settings/categories/List'),
      name: 'CategoryList',
      meta: { title: 'categories', icon: 'category', permissions: ['view category', 'manage category'] },
    },
    /** Settings */
    {
      path: 'configuration',
      component: () => import('@/views/settings/index'),
      name: 'Configuration',
      meta: { title: 'configuration', icon: 'config', permissions: ['view category', 'manage category'] },
    },
  ],
};

export default settingsRoutes;
