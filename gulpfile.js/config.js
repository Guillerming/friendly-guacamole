exports.cfg = {
  date: new Date().getTime(),
  path: {
    dist: 'build/',
  },
  sass: {
    outputStyle: 'compressed'
  },
  env: {
    dev: {
      production: false,
      local: true,
      base_url: 'https://localhost.friendly-guacamole.com:8890/',
      api: {},
      keys: {}
    },
    staging: {
      production: false,
      local: false,
      base_url: 'https://dev.friendly-guacamole.com/',
      api: {},
      keys: {}
    },
    prod: {
      production: true,
      local: false,
      base_url: 'https://friendly-guacamole.com/',
      api: {},
      keys: {}
    },
  }
};