from flask import Flask, request, jsonify
import requests
from flask_cors import CORS  # Menambahkan CORS

app = Flask(__name__)
CORS(app)  # Mengizinkan akses dari frontend

# API Key harus disimpan dengan aman (gunakan .env atau variabel lingkungan)
API_KEY = "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"  # Gantilah dengan API Key Anda
URL = "https://openrouter.ai/api/v1/chat/completions"

@app.route("/")
def home():
    return "Chatbot API is running!"  # Cek apakah server berjalan

@app.route("/chat", methods=["POST"])
def chat():
    try:
        user_input = request.json.get("message")

        headers = {
            "Authorization": f"Bearer {API_KEY}",
            "Content-Type": "application/json"
        }

        data = {
            "model": "openai/gpt-3.5-turbo",
            "messages": [
                {"role": "system", "content": "You are a helpful assistant."},
                {"role": "user", "content": user_input}
            ]
        }

        response = requests.post(URL, headers=headers, json=data)

        if response.status_code == 200:
            reply = response.json().get("choices", [{}])[0].get("message", {}).get("content", "Maaf, ada kesalahan.")
            return jsonify({"reply": reply})
        else:
            return jsonify({"error": "Gagal mendapatkan respons dari OpenRouter"}), 500

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True)
