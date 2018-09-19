import request from '@/utils/request'

/**
 * 获取用户组列表
 * @param data
 */
export function fetchList(data) {
  return request({
    url: '/roles/get-list',
    method: 'post',
    data: data
  })
}

/**
 * key-value 形式返回所有用户组列表
 */
export function getListAll() {
  return request({
    url: '/roles/get-list-all',
    method: 'post'
  })
}

/**
 * 新增用户组
 * @param data
 */
export function createRole(data) {
  return request({
    url: '/roles/add',
    method: 'post',
    data: data
  })
}

/**
 * 编辑用户组
 * @param data
 */
export function updateRole(data) {
  return request({
    url: '/roles/edit',
    method: 'post',
    data: data
  })
}

/**
 * 删除
 * @param data
 */
export function deleteRole(data) {
  return request({
    url: '/roles/delete',
    method: 'post',
    data: data
  })
}
