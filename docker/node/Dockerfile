FROM node:20

# Set working directory
WORKDIR /var/www

# Copy package.json and package-lock.json
COPY package*.json ./

# Install Node.js dependencies
RUN npm install

# Copy application code
COPY . .

# Expose Vite port
EXPOSE 5173

# Start Vite server
CMD ["npm", "run", "dev"]