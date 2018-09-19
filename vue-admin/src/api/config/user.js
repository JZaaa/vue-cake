import request from '@/utils/request'

/**
 * 获取列表
 */
export function getList(data) {
  return request({
    url: '/users/get-list',
    method: 'post',
    data: data
  })
}

/**
 * 添加
 */
export function createData(data) {
  return request({
    url: '/users/add',
    method: 'post',
    data: data
  })
}

/**
 * 编辑
 */
export function updateData(data) {
  return request({
    url: '/users/edit',
    method: 'post',
    data: data
  })
}

/**
 * 删除
 */
export function deleteData(data) {
  return request({
    url: '/users/delete',
    method: 'post',
    data: data
  })
}
