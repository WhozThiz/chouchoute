/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const productivityRoutes = {
  path: '/productivity',
  component: Layout,
  redirect: '/productivity',
  name: 'Productivity',
  meta: {
    title: 'productivity',
    icon: 'task-list',
    permissions: ['view menu productivity routes'],
  },
  children: [
    {
      path: 'todo',
      component: () => import('@/views/productivity/todo/index'),
      name: 'ToDo',
      meta: { title: 'todo', icon: 'todo' },
    },
    {
      path: 'task',
      component: () => import('@/views/productivity/task/index'),
      name: 'Task',
      meta: { title: 'tasks', icon: 'tasks' },
    },
  ],
};

export default productivityRoutes;
