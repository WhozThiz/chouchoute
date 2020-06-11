/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const cmsRoutes = {
  path: '/cms',
  component: Layout,
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
      meta: { title: 'articleList', icon: 'articles', permissions: ['manage article'] },
    },
    /** Post Managements */
    {
      path: 'posts',
      component: () => import('@/views/cms/posts/list'),
      name: 'PostList',
      meta: { title: 'postList', icon: 'edit' },
    },
  ],
};

export default cmsRoutes;
