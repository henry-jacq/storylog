from dotenv import load_dotenv
import os

load_dotenv()

class Settings:
    PROJECT_NAME = "Storylog"
    DATABASE_URL = os.getenv("DATABASE_URL")
    FRONTEND_URL = os.getenv("FRONTEND_URL")

settings = Settings()
