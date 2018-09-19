import request from '@/utils/request'

/**
 * 获取列表
 */
export function getList(data) {
  return request({
    url: '/arctypes/get-list',
    method: 'post',
    data: data
  })
}

export function getListAll() {
  return request({
    url: '/arctypes/get-list-all',
    method: 'post'
  })
}

/**
 * 添加
 */
export function createData(data) {
  return request({
    url: '/arctypes/add',
    method: 'post',
    data: data
  })
}

/**
 * 编辑
 */
export function updateData(data) {
  return request({
    url: '/arctypes/edit',
    method: 'post',
    data: data
  })
}

/**
 * 删除
 */
export function deleteData(data) {
  return request({
    url: '/arctypes/delete',
    method: 'post',
    data: data
  })
}
