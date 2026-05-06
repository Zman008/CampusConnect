# Community Chat Setup Guide

## ✅ Setup Complete

The Community Chat feature is **fully functional** and ready to use. Logged-in users can participate in university-related group discussions with real-time messaging (when configured) or instant persistence (current setup).

## What's Included

- **6 Pre-made Groups**: Computer Science, Engineering, Business, Arts & Humanities, Science, and General Discussion
- **Message Persistence**: All messages are saved to the database
- **User Attribution**: Messages display sender's username and timestamp
- **Database Relationships**: Proper model relationships and foreign keys
- **Authentication Protection**: Only logged-in users can view/send messages
- **Open Access**: Any authenticated user can access all groups
- **WebSocket Ready**: Infrastructure in place for real-time updates

## Running the Application

### Start the Laravel Server
```bash
php artisan serve
```
The app will be available at `http://127.0.0.1:8000`

If using Laravel Herd, the app should be automatically served at your configured domain.

### Start Frontend Build (Vite)
```bash
npm run dev
```
This compiles the JavaScript/CSS and enables hot reloading.

## Accessing the Community

1. **Navigate to Community**: Click "Community" in the top navigation
2. **View Groups**: See all university-related groups
3. **Join a Chat**: Click "Join Chat" to enter any group
4. **Send Messages**: Type a message and click "Send"
5. **View History**: All previous messages are displayed

## Current Broadcasting Setup

The system currently uses **Log Broadcasting** for testing. Messages are:
- ✅ Saved to database immediately
- ✅ Visible when page is loaded/refreshed
- ✅ Persisted permanently
- ⚠️ Not real-time (page refresh required to see new messages from others)

## Enabling Real-Time WebSockets

Choose one of the following options:

### Option 1: Using Pusher (Recommended for Production)

1. **Create a Pusher Account**
   - Visit https://pusher.com and sign up (free tier available)
   - Create a new app and get your credentials

2. **Configure `.env` file**
   ```
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your_app_id
   PUSHER_APP_KEY=your_app_key
   PUSHER_APP_SECRET=your_app_secret
   PUSHER_APP_CLUSTER=mt1
   ```

3. **Update Frontend Configuration**
   Add to `.env`:
   ```
   VITE_PUSHER_APP_KEY=your_app_key
   VITE_PUSHER_APP_CLUSTER=mt1
   ```

4. **Rebuild Assets**
   ```bash
   npm run build
   ```

5. **Restart Server**
   ```bash
   php artisan serve
   ```

### Option 2: Using Redis with Laravel Reverb (For Local Development)

1. **Ensure Redis is Running**
   - Redis should be running on `127.0.0.1:6379`

2. **Install Laravel Reverb** (if not already installed)
   ```bash
   composer require laravel/reverb --dev
   php artisan reverb:install
   ```

3. **Configure Broadcasting**
   ```
   BROADCAST_DRIVER=redis
   ```

4. **Run Reverb Server** (in a separate terminal)
   ```bash
   php artisan reverb:start
   ```

5. **Keep Vite Dev Server Running**
   ```bash
   npm run dev
   ```

6. **Start Laravel Server**
   ```bash
   php artisan serve
   ```

## Database Schema

### community_groups table
```
id          - Integer (Primary Key)
name        - String (Group name)
description - Text (Group description)
created_at  - Timestamp
updated_at  - Timestamp
```

### community_messages table
```
id          - Integer (Primary Key)
group_id    - Integer (Foreign Key → community_groups)
user_id     - Integer (Foreign Key → users)
message     - Text (Message content)
created_at  - Timestamp
updated_at  - Timestamp
```

## API Endpoints (All Require Authentication)

### View Routes
- `GET /community` - List all groups
- `GET /community/group/{groupId}` - View specific group chat

### API Routes
- `POST /community/group/{groupId}/message` - Send a message
  - Body: `{ "message": "Your message here" }`
  - Returns: `{ "success": true, "message": {...} }`

- `GET /community/group/{groupId}/messages` - Get all messages for a group
  - Returns: `{ "messages": [...] }`

## Broadcasting Channels

**Private Channel**: `community.group.{groupId}`
- Only authenticated users can subscribe
- Receives `MessageSent` event when new messages are posted

**Event**: `MessageSent`
- Fired when a user sends a message
- Contains the full message object with user details

## Frontend Features

- **Real-time Message Updates**: When WebSockets are configured
- **Fallback Mode**: Works without WebSockets, messages appear on refresh
- **XSS Protection**: Message content is properly escaped
- **Duplicate Prevention**: Messages won't be added twice
- **Auto-scroll**: Chat automatically scrolls to latest messages
- **Loading States**: Send button shows "Sending..." state with disabled state
- **Error Handling**: Displays user-friendly error messages

## Troubleshooting

### Messages not showing in real-time
- Check if WebSockets are configured (Pusher, Redis, or Reverb)
- Verify `BROADCAST_DRIVER` is set correctly in `.env`
- Check browser console for JavaScript errors
- Ensure both Laravel and Vite servers are running

### Messages not saving
- Verify migrations have run: `php artisan migrate`
- Check database connection in `.env`
- Ensure user is logged in

### "Failed to listen" error when starting server
- Check if port 8000 is already in use
- Run with a different port: `php artisan serve --port=8001`

### WebSocket connection fails
- Verify Pusher credentials are correct (if using Pusher)
- Check if `VITE_PUSHER_*` variables match `PUSHER_*` in `.env`
- Ensure Reverb server is running (if using Reverb)

## Features Summary

✅ Multi-group chat system
✅ Database persistence
✅ User authentication required
✅ Real-time messaging ready (when WebSockets configured)
✅ Message history
✅ Open group access (any authenticated user)
✅ No user-created groups (admin-managed)
✅ User identification on messages
✅ Timestamps on all messages
✅ XSS protection
✅ Responsive design
✅ Error handling and validation

## Next Steps

1. Test the application by logging in and sending messages
2. (Optional) Set up Pusher for real-time messaging
3. (Optional) Configure Redis + Reverb for local real-time testing
4. Customize group names and descriptions as needed
5. Add additional groups via database seeder
