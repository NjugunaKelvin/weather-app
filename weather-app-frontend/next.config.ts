/** @type {import('next').NextConfig} */
interface WebpackConfig {
  resolve: {
    fallback: {
      fs: boolean;
      path: boolean;
    };
  };
}

interface NextConfig {
  webpack: (config: WebpackConfig) => WebpackConfig;
}

const nextConfig: NextConfig = {
  webpack: (config) => {
    config.resolve.fallback = { 
      fs: false,
      path: false 
    };
    return config;
  }
}

module.exports = nextConfig;