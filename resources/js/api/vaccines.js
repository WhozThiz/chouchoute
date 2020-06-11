import request from '@/utils/request';
import Resource from '@/api/resource';

class VaccinesResource extends Resource {
  vaccines(query) {
    return request({
      url: '/vaccines',
      method: 'get',
      params: query,
    });
  }
}

export { VaccinesResource as default };
