from dotenv import load_dotenv
import os

load_dotenv()

class Settings:
    PROJECT_NAME = "Storylog"
    DATABASE_URL = os.getenv("DATABASE_URL")

settings = Settings()
