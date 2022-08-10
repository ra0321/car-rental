import { 
  DashboardOutlined,
  WindowsOutlined,
  CarOutlined,
  TeamOutlined,
  EuroCircleOutlined,
  SolutionOutlined,
  LogoutOutlined,
  TrophyOutlined ,
  FileDoneOutlined
} from '@ant-design/icons';
import { APP_PREFIX_PATH } from 'configs/AppConfig'

const dashBoardNavTree = [{
  key: 'dashboard',
  path: `${APP_PREFIX_PATH}/dashboard`,
  title: 'sidenav.menu.dashboard',
  icon: WindowsOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'cars',
  path: `${APP_PREFIX_PATH}/cars`,
  title: 'sidenav.menu.cars',
  icon: CarOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'cars_data',
  path: `${APP_PREFIX_PATH}/cars_data`,
  title: 'sidenav.menu.cars_data',
  icon: FileDoneOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'list_car',
  path: `${APP_PREFIX_PATH}/list_car`,
  title: 'sidenav.menu.list_car',
  icon: FileDoneOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'users',
  path: `${APP_PREFIX_PATH}/users`,
  title: 'sidenav.menu.users',
  icon: TeamOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'trips',
  path: `${APP_PREFIX_PATH}/trips`,
  title: 'sidenav.menu.trips',
  icon: DashboardOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'earings',
  path: `${APP_PREFIX_PATH}/earnings`,
  title: 'sidenav.menu.earings',
  icon: EuroCircleOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'role',
  path: `${APP_PREFIX_PATH}/role`,
  title: 'sidenav.menu.role',
  icon: TrophyOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'admin',
  path: `${APP_PREFIX_PATH}/admin`,
  title: 'sidenav.menu.admin',
  icon: SolutionOutlined,
  breadcrumb: false,
  submenu: []
},{
  key: 'logout',
  path: `${APP_PREFIX_PATH}/logout`,
  title: 'sidenav.menu.logout',
  icon: LogoutOutlined,
  breadcrumb: false,
  submenu: []
}]

const navigationConfig = [
  ...dashBoardNavTree
]

export default navigationConfig;
