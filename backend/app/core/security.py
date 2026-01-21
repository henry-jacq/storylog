from passlib.context import CryptContext

pwd_context = CryptContext(
    schemes=["bcrypt"],
    deprecated="auto",
)

MAX_BCRYPT_LEN = 72

def hash_password(password: str) -> str:
    # bcrypt hard limit
    if len(password.encode("utf-8")) > MAX_BCRYPT_LEN:
        raise ValueError("Password too long (max 72 bytes)")

    return pwd_context.hash(password)


def verify_password(password: str, hashed: str) -> bool:
    return pwd_context.verify(password, hashed)
