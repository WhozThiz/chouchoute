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
      component: () => import('@/views/articles/List'),
      name: 'Articles',
      meta: { title: 'articleList', icon: 'articles' },
      children: [
        /** Articles */
        {
          path: 'articles',
          component: () => import('@/views/articles/List'),
          name: 'ArticleList',
          meta: { title: 'articleList', icon: 'articles', permissions: ['manage article'] },
        },
        {
          path: 'articles/edit/:id(\\d+)',
          component: () => import('@/views/articles/Edit'),
          name: 'EditArticle',
          meta: { title: 'editArticle', noCache: true, permissions: ['manage article'] },
          hidden: true,
        },
        {
          path: 'articles/create',
          component: () => import('@/views/articles/Create'),
          name: 'CreateArticle',
          meta: { title: 'createArticle', icon: 'edit', permissions: ['manage article'] },
          hidden: true,
        },
      ],
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
