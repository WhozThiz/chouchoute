/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const cmsRoutes = {
  path: '/cms',
  component: Layout,
  redirect: '/cms',
  name: 'CMS',
  meta: {
    title: 'cms',
    icon: 'management',
    permissions: ['view menu cms routes'],
  },
  children: [
    /** Article Managements */
    {
      path: 'articles',
      component: () => import('@/views/cms/articles/Articles'),
      name: 'Articles',
      meta: { title: 'articles', icon: 'articles', permissions: ['manage article'] },
    },
    /** Post Managements */
    {
      path: 'posts',
      component: () => import('@/views/cms/posts/list'),
      name: 'PostList',
      meta: { title: 'postList', icon: 'edit', permissions: ['manage article'] },
    },
  ],
};

export default cmsRoutes;
