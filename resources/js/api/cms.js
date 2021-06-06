import request from '@/utils/request';
import Resource from '@/api/resource';

class CmsResource extends Resource {
  articles(query) {
    return request({
      url: '/articles',
      method: 'get',
      params: query,
    });
  }
}

export { CmsResource as default };
