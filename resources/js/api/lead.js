import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/leads',
    method: 'get',
    params: query,
  });
}

export function fetchLead(id) {
  return request({
    url: '/leads/' + id,
    method: 'get',
  });
}

export function fetchPv(id) {
  return request({
    url: '/leads/' + id + '/pageviews',
    method: 'get',
  });
}

export function createLead(data) {
  return request({
    url: '/lead/create',
    method: 'post',
    data,
  });
}

export function updateLead(data) {
  return request({
    url: '/lead/update',
    method: 'post',
    data,
  });
}
