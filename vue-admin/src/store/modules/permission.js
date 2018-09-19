import { asyncRouterMap, constantRouterMap } from '@/router'
import { getMenus } from '@/api/login'

function filterAsyncRouter(asyncRouter) {
  asyncRouter.forEach(function(item, index) {
    item.component = asyncRouterMap[item.component]
    if (item.children && item.children.length > 0) {
      filterAsyncRouter(item.children)
    }
  })
  return asyncRouter
}

const permission = {
  state: {
    routers: constantRouterMap,
    addRouters: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers
      state.routers = constantRouterMap.concat(routers)
    }
  },
  actions: {
    GenerateRoutes({ commit }, data) {
      return new Promise((resolve, reject) => {
        getMenus().then(response => {
          const routers = filterAsyncRouter(response).concat({ path: '*', redirect: '/404', hidden: true })
          commit('SET_ROUTERS', routers)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}

export default permission
