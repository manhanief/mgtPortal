<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        .container {
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        .error-code {
            font-size: 10rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 4px 4px 20px rgba(0,0,0,0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        button {
            padding: 1rem 2rem;
            font-size: 1rem;
            border: 2px solid white;
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        button:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float-random 20s infinite ease-in-out;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 30%;
            top: 70%;
            left: 80%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 20%;
            top: 40%;
            left: 5%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            top: 20%;
            left: 85%;
            animation-delay: 1s;
        }

        @keyframes float-random {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, 20px) rotate(180deg); }
            75% { transform: translate(20px, 30px) rotate(270deg); }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }
            h1 {
                font-size: 1.8rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="container">
        <div class="error-code">404</div>
        <h1>Oops! Page Not Found</h1>
        <p>The page you're looking for seems to have wandered off into the digital void.</p>
        <div class="button-group">
            <button onclick="window.history.back()">Go Back</button>
            <button onclick="window.location.href='/'">Home Page</button>
        </div>
    </div>

    <script>
        // Add cursor trail effect
        document.addEventListener('mousemove', (e) => {
            const trail = document.createElement('div');
            trail.style.cssText = `
                position: fixed;
                width: 10px;
                height: 10px;
                background: rgba(255,255,255,0.5);
                border-radius: 50%;
                pointer-events: none;
                left: ${e.clientX - 5}px;
                top: ${e.clientY - 5}px;
                animation: trail-fade 1s ease-out forwards;
                z-index: 5;
            `;
            document.body.appendChild(trail);
            setTimeout(() => trail.remove(), 1000);
        });

        const style = document.createElement('style');
        style.textContent = `
            @keyframes trail-fade {
                to {
                    opacity: 0;
                    transform: scale(2);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>