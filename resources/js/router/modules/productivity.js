/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const productivityRoutes = {
  path: '/productivity',
  component: Layout,
  redirect: '/productivity',
  name: 'Productivity',
  meta: {
    title: 'productivity',
    icon: 'star',
    permissions: ['view menu productivity routes'],
  },
  children: [
    {
      path: 'todo',
      component: () => import('@/views/productivity/todo/index'),
      name: 'ToDo',
      meta: { title: 'todo' },
    },
    {
      path: 'task',
      component: () => import('@/views/productivity/task/index'),
      name: 'Task',
      meta: { title: 'tasks' },
    },
  ],
};

export default productivityRoutes;
