<div class="loading-spinner load-page d-none">
    <div class="spinner"></div>
    <p>Uploading, please wait...</p>
</div>

<style>
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(116, 114, 114, 0.548);
        backdrop-filter: blur(5px);
        z-index: 999999;
        flex-direction: column;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(62, 136, 62, 0.2);
        border-top: 5px solid rgb(62, 136, 62);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    p {
        margin-top: 10px;
        font-size: 16px;
        color: rgb(62, 136, 62);
    }
</style>
