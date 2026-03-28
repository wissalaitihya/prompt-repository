<?php 
include '../includes/header.php'; ?>

<style>
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes cardHover {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-8px);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

main {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.dashboard-header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    animation: slideInUp 0.6s ease-out;
}

.dashboard-header h1 {
    font-size: 42px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
    text-shadow: 0 2px 20px rgba(255, 107, 157, 0.1);
}

.dashboard-header > p {
    font-size: 16px;
    color: #666;
    font-weight: 500;
}

/* Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    animation: slideInUp 0.7s ease-out 0.1s backwards;
}

/* Card Styling */
.card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
    border: 1px solid rgba(255, 107, 157, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease-out backwards;
}

.card:nth-child(1) { animation-delay: 0.2s; }
.card:nth-child(2) { animation-delay: 0.3s; }
.card:nth-child(3) { animation-delay: 0.4s; }

.card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.2) 0%, transparent 100%);
    border-radius: 50%;
    transition: all 0.6s ease;
    z-index: 0;
}

.card:hover::before {
    top: -20px;
    right: -20px;
    width: 150px;
    height: 150px;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(255, 107, 157, 0.2);
    border-color: rgba(255, 107, 157, 0.4);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
}

.card-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    position: relative;
    z-index: 1;
}

.card-content {
    position: relative;
    z-index: 1;
}

.card-description {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    position: relative;
    z-index: 1;
}

.stat {
    font-size: 24px;
    font-weight: 800;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.badge {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(255, 107, 157, 0.3);
}

/* Stats Section */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
    animation: slideInUp 0.8s ease-out 0.2s backwards;
}

.stat-box {
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    text-align: center;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.25);
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(255, 107, 157, 0.35);
}

.stat-box-number {
    font-size: 48px;
    font-weight: 900;
    margin-bottom: 10px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.stat-box-label {
    font-size: 14px;
    opacity: 0.95;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header h1 {
        font-size: 32px;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<main>
    <div class="dashboard-header">
        <h1>Welcome to PromptHub 🚀</h1>
        <p>Manage your prompts and content efficiently</p>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <div class="card-icon">📝</div>
                <div class="card-title">My Prompts</div>
            </div>
            <div class="card-content">
                <p class="card-description">Create, edit, and manage your custom prompts with ease.</p>
                <div class="card-footer">
                    <span class="stat">42</span>
                    <span class="badge">Active</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-icon">⭐</div>
                <div class="card-title">Favorites</div>
            </div>
            <div class="card-content">
                <p class="card-description">Your saved and favorite prompts for quick access.</p>
                <div class="card-footer">
                    <span class="stat">18</span>
                    <span class="badge">Popular</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-icon">📊</div>
                <div class="card-title">Analytics</div>
            </div>
            <div class="card-content">
                <p class="card-description">Track usage and performance metrics of your prompts.</p>
                <div class="card-footer">
                    <span class="stat">85%</span>
                    <span class="badge">Engagement</span>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-box-number">156</div>
            <div class="stat-box-label">Total Prompts</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-number">2.4k</div>
            <div class="stat-box-label">Total Views</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-number">98</div>
            <div class="stat-box-label">Shared</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-number">App</div>
            <div class="stat-box-label">v2.1.0</div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
